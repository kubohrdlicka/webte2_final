from sympy import Float
from sympy import *
from sympy.parsing.latex import parse_latex


x =  r"\dfrac{2.000000001s^2+13s+10}{s^3+7s^2+18s+15} "
y = r"\dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}"


expr1 = parse_latex(x)
expr2 = parse_latex(y)

rounded_expr1 = expr1

rounded_expr2 = expr2

for a in preorder_traversal(expr1):
    if isinstance(a, Float):
        rounded_expr1 = expr1.subs(a, round(a, 4))




for a in preorder_traversal(expr2):
    if isinstance(a, Float):
        rounded_expr2 = expr2.subs(a, round(a, 4))


print(expr1)
print(rounded_expr1)
print(rounded_expr2)
print(rounded_expr1.equals(rounded_expr2))




#
# solution = parse_latex(x)
# given_solution = parse_latex(y)
#
# print(solution.equals(given_solution))


